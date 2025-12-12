import React, { useEffect, useState } from "react";

/** チャットコンポーネント */
export default function ChatArea({ chatClient }) {
    const [message, setMessage] = useState("");
    const [messageList, setMessageList] = useState([]);

    useEffect(() => {
        chatClient.addMessage = (row) => {
            setMessageList((list) => [row, ...list]);
        };
    }, []);

    const sendMessage = (type) => {
        console.log(message);
        chatClient.sendMessage(message, type);
        setMessage("");
    };

    const handleKeyDown = (e) => {
        if (e.key === "Enter") sendMessage('websocket');
    };

    return (
        <div className="max-w-2xl mx-auto py-6">
            <div>
                <input
                    type="text"
                    value={message}
                    className="border p-1 mr-2 w-2/3"
                    onKeyDown={handleKeyDown}
                    onChange={(e) => setMessage(e.target.value)}
                />
                <button
                    className="p-1 border bg-gray-200 ml-2"
                    onClick={() => sendMessage('websocket')}
                >
                    Send (W)
                </button>
                <button
                    className="p-1 border bg-gray-200 ml-2"
                    onClick={() => sendMessage('redis')}
                >
                    Send (R)
                </button>
            </div>

            <div className="border border-gray-700 p-2 mb-2 h-80 mt-5 overflow-y-auto">
                {messageList.map((data, index) => (
                    <p key={index}>
                        {data.data.message}
                        <span className="ml-2 text-sm text-gray-400">
                            by {data.data.name}
                        </span>
                    </p>
                ))}
            </div>
        </div>
    );
}
