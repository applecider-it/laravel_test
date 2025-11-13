import React, { useState } from 'react';
import TweetForm from './tweet-app/TweetForm';
import TweetList from './tweet-app/TweetList';
import axios from 'axios';

export default function TweetApp({ initialTweets }) {
    const [tweets, setTweets] = useState(initialTweets);
    const [content, setContent] = useState('');
    const [errors, setErrors] = useState({});

    // handleSubmit も親で管理
    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const response = await axios.post('/tweets/api', { content });
            setTweets([response.data, ...tweets]);
            setContent('');
            setErrors({});
        } catch (error) {
            if (error.response?.status === 422) {
                setErrors(error.response.data.errors);
            }
        }
    };

    return (
        <div>
            <TweetForm
                content={content}
                setContent={setContent}
                errors={errors}
                onSubmit={handleSubmit} // フォームの submit は親に任せる
            />
            <TweetList tweets={tweets} />
        </div>
    );
}
