from fastapi import FastAPI
from app.config import add_middlewares
from app.routers import predict

app = FastAPI()

# ミドルウェア追加
add_middlewares(app)

# ルーター追加
app.include_router(predict.router)

if __name__ == "__main__":
     # 直接実行した時

    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8090)
