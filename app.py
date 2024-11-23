
from flask import Flask, render_template, request
import chess
import chess.engine

app = Flask(__name__)

# Set up Stockfish engine
engine_path = r'stockfish\stockfish-windows-x86-64-avx2.exe'
engine = chess.engine.SimpleEngine.popen_uci(engine_path)

# Track user and opponent moves
user_moves = []
opponent_moves = []

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/analyze', methods=['POST'])
def analyze():
    global user_moves, opponent_moves

    user_moves_str = request.form.get('user_moves', '')
    opponent_move = request.form.get('opponent_move', '')

    # Initialize the board
    board = chess.Board()

    # Apply opponent's move
    if opponent_move:
        try:
            move = chess.Move.from_uci(opponent_move)
            board.push(move)
            opponent_moves.append(opponent_move)
        except ValueError:
            return render_template('index.html', show_result=False, coaching_feedback='Invalid opponent move format')

    # Apply user's moves
    for user_move in user_moves_str.split():
        try:
            move = chess.Move.from_uci(user_move)
            board.push(move)
            user_moves.append(user_move)
        except ValueError:
            return render_template('index.html', show_result=False, coaching_feedback='Invalid user move format')

    try:
        # Analyze the position and generate insights for the next move
        analysis = engine.analyse(board, chess.engine.Limit(time=5.0))  # Increased time limit for analysis
        best_move = analysis.get("pv")[0]
        coaching_insight = get_coaching_insight(best_move, board)
        return render_template('index.html', show_result=True, user_moves=user_moves, opponent_moves=opponent_moves, best_move=str(best_move), coaching_insight=coaching_insight)
    except TimeoutError:
        # If there's a timeout, return a custom response
        return render_template('index.html', show_result=False, coaching_feedback='Entered move is a correct move.')

def get_coaching_insight(stockfish_move, board):
    insight = ""

    # Enhanced coaching insights based on move and board context
    if board.is_capture(stockfish_move):  
        insight += "Captures are often valuable, but consider the consequences."
        captured_piece = board.piece_at(stockfish_move.to_square)  # Access captured piece if needed
        if captured_piece:
            insight += f" You captured a {captured_piece}."

    if board.is_castling(stockfish_move):
        insight += "Castling can improve king safety and connect rooks."

    # General insights
    if board.is_capture(stockfish_move):
        insight += "Captures are often valuable, but consider the consequences."
    elif stockfish_move.promotion:
        insight += "Promotions are powerful, choose wisely!"
    elif board.is_attacked_by(board.turn, stockfish_move.to_square):
        insight += "Attacks can create pressure, but defend your pieces too."
    elif stockfish_move.uci() == 'O-O':
        insight += "Castling kingside protects your king and activates a rook."
    elif stockfish_move.uci() == 'O-O-O':
        insight += "Castling queenside can also help develop your rook and improve king safety."
    else:
        insight += "Developing pieces and controlling the center are often good strategies."

    # Specific insights based on move type (customize as needed)
    if stockfish_move.uci() == 'e2e4':
        insight += "This strong move opens up lines for your pieces and stakes a claim in the center."
    elif stockfish_move.uci() == 'Nf3':
        insight += "Developing knights early helps control the center and prepares for future attacks."

    # Contextual insights based on board position (customize as needed)
    if board.is_check():
        insight += "Defending against check is crucial!"
    elif len(list(board.legal_moves)) < 5:
        insight += "Be cautious in tight positions, every move counts."

    return insight
if __name__ == '__main__':
    app.run(debug=True)
