import React from 'react';

export default function TweetForm({ content, setContent, errors, onSubmit }) {
    return (
        <form onSubmit={onSubmit} className="mb-4">
            <textarea
                rows={3}
                className="w-full border rounded p-2"
                placeholder="What's happening?"
                value={content}
                onChange={(e) => setContent(e.target.value)}
            />
            {errors.content && <p className="app-error-text">{errors.content[0]}</p>}
            <button type="submit" className="mt-2 app-btn-primary">Tweet</button>
        </form>
    );
}
