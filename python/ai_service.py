# ai_service.py
from fastapi import FastAPI
from pydantic import BaseModel
from fastapi.middleware.cors import CORSMiddleware

app = FastAPI()

# CORSを許可しておく（開発用）
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_methods=["*"],
    allow_headers=["*"],
)

class RequestData(BaseModel):
    text: str

@app.post("/predict")
async def predict(data: RequestData):
    # 適当な処理（ここをAIモデル呼び出しに置き換え）
    result = data.text.upper()  # とりあえず大文字変換
    return {"result": result, "aaa": "bbb"}

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8090)
