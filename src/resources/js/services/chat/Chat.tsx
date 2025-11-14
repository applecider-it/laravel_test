import React, { useEffect, useState } from "react";

/** チャットコンポーネント */
export default function Chat({ chatClient }) {
    const [message, setMessage] = useState("");
    const [messageList, setMessageList] = useState([]);

    useEffect(() => {
        chatClient.setMessageList = setMessageList;
    }, []);

    const sendMessage = () => {
        console.log(message);
        chatClient.sendMessage(message);
        setMessage("");
    };

    const handleKeyDown = (e) => {
        if (e.key === "Enter") sendMessage();
    };

    return (
        <div className="max-w-2xl mx-auto py-6">
            <div>
                <input
                    type="text"
                    value={message}
                    className="border p-1 mr-2 w-3/4"
                    onKeyDown={handleKeyDown}
                    onChange={(e) => setMessage(e.target.value)}
                />
                <button
                    className="p-1 border bg-gray-200"
                    onClick={sendMessage}
                >
                    Send
                </button>
            </div>

            <div className="border p-2 mb-2 h-80 overflow-y-auto">
                {messageList.map((data, index) => (
                    <p key={index}>
                        <strong>{data.info.name}</strong>: {data.data.message}
                    </p>
                ))}
            </div>
        </div>
    );
}
