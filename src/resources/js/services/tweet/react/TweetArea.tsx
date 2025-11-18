import React, { useEffect, useState } from 'react';
import TweetForm from './tweet-area/TweetForm';
import TweetList from './tweet-area/TweetList';
import TweetClient from "../TweetClient";
import { setIsLoading } from "@/services/ui/message";

type Prop = {
    initialTweets: any;
    tweetClient: TweetClient;
}

export default function TweetApp({ initialTweets, tweetClient } : Prop) {
    const [tweetContainers, setTweetContainers] = useState([]);
    const [content, setContent] = useState('');
    const [errors, setErrors] = useState({});

    useEffect(() => {
        tweetClient.setTweetContainers = setTweetContainers;
        const list: any = [];
        for (const tweet of initialTweets) {
            list.push({
                tweet,
                isNew: false
            })
        }
        setTweetContainers(list);
    }, []);

    // handleSubmit も親で管理
    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            setIsLoading(true);
            await tweetClient.sendTweet(content);
            setIsLoading(false);
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
            <TweetList tweetContainers={tweetContainers} />
        </div>
    );
}
