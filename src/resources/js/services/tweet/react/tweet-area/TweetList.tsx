import React from "react";

export default function TweetList({ tweetContainers }) {
    return (
        <div className="space-y-4">
            {tweetContainers.map((tweetContainer) => (
                <div
                    key={tweetContainer.tweet.id}
                    className="border rounded p-4"
                >
                    {tweetContainer.isNew ? (
                        <p className="text-blue-500">new</p>
                    ) : null}
                    <p className="text-gray-800">
                        {tweetContainer.tweet.content}
                    </p>
                    <p className="text-gray-500 text-sm">
                        by {tweetContainer.tweet.user.name} -{" "}
                        {new Date(
                            tweetContainer.tweet.created_at
                        ).toLocaleString()}
                    </p>
                </div>
            ))}
        </div>
    );
}
