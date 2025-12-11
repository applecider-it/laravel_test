from app.services.generate import generate_text

# AIの処理をここにまとめる
def process_text(text: str) -> str:
    source = text

    return generate_text(source, 40)
