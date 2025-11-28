from fastapi import APIRouter
from app.models.request import RequestData
from app.services.ai_model import process_text

router = APIRouter()

@router.post("/predict")
async def predict(data: RequestData):
    result = process_text(data.text)
    return {"result": result, "aaa": "bbb"}
