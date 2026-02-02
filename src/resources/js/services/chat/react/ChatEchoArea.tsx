import React, { useEffect, useState } from "react";

import ChatClient from "../ChatEchoClient";

type Prop = {
    chatClient: ChatClient;
};

/** チャット(Echo)コンポーネント */
export default function ChatEchoArea({ chatClient }: Prop) {
    const [message, setMessage] = useState("");
    const [messageList, setMessageList] = useState([]);
    const [userList, setUserList] = useState([]);

    useEffect(() => {
        chatClient.addMessage = (row) => {
            setMessageList((list) => [row, ...list]);
        };
        chatClient.setUsers = (users) => {
            console.log('users', users);
            setUserList([...users]);
        }
    }, []);

    const sendMessage = (type, options: any = []) => {
        console.log(message);
        chatClient.sendMessage(message, type, options);
        setMessage("");
    };

    const handleKeyDown = (e) => {
        if (e.key === "Enter") sendMessage("echo");
    };

    return (
        <div className="max-w-2xl mx-auto py-6">
            <div>
                <input
                    type="text"
                    value={message}
                    className="border p-1 mr-2 w-80"
                    onKeyDown={handleKeyDown}
                    onChange={(e) => setMessage(e.target.value)}
                />
                <button
                    className="p-1 border bg-gray-200 ml-2"
                    onClick={() => sendMessage("echo")}
                >
                    Send (E)
                </button>
                <button
                    className="p-1 border bg-gray-200 ml-2"
                    onClick={() => sendMessage("echo", {others: true})}
                >
                    Send (E,O)
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

            <div className="mt-5">
                接続ユーザー一覧
                <div className="border-2 border-gray-300 p-2 mb-2 h-40 mt-2 overflow-y-auto">
                    {userList.map((user, index) => (
                        <p key={index}>
                            {user.id} {user.name}
                        </p>
                    ))}
                </div>
            </div>
        </div>
    );
}
