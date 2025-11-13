import React from 'react';

export default function TweetList({ tweets }) {
    return (
        <div className="space-y-4">
            {tweets.map(tweet => (
                <div key={tweet.id} className="border rounded p-4">
                    <p className="text-gray-800">{tweet.content}</p>
                    <p className="text-gray-500 text-sm">
                        by {tweet.user.name} - {new Date(tweet.created_at).toLocaleString()}
                    </p>
                </div>
            ))}
        </div>
    );
}
