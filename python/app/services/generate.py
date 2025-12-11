import random

# テキスト生成
def generate_text(text, length=50):
    words = text.split()
    markov = {}

    # マルコフ連鎖を作成
    for i in range(len(words)-1):
        key = words[i]
        next_word = words[i+1]
        markov.setdefault(key, []).append(next_word)

    # 初期単語
    word = random.choice(words)
    result = [word]

    # 文章生成
    for _ in range(length):
        next_words = markov.get(word, words)
        word = random.choice(next_words)
        result.append(word)

    return " ".join(result)
