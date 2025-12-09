import React, { useEffect, useState } from "react";
import TweetForm from "./tweet-area/TweetForm";
import TweetList from "./tweet-area/TweetList";
import TweetClient from "../TweetClient";
import { setIsLoading } from "@/services/ui/message";

type Prop = {
    initialTweets: any;
    tweetClient: TweetClient;
};

export default function TweetApp({ initialTweets, tweetClient }: Prop) {
    const [tweetContainers, setTweetContainers] = useState([]);
    const [content, setContent] = useState("");
    const [errors, setErrors] = useState({});

    useEffect(() => {
        tweetClient.addTweet = (tweet) => {
            setTweetContainers((list) => [{ tweet, isNew: true }, ...list]);
        };

        setTweetContainers(makeTweetContainers(initialTweets));
    }, []);

    /** ツイート一覧から、ツイートコンテナー一覧を作成 */
    const makeTweetContainers = (tweets) => {
        const list: any = [];
        for (const tweet of tweets) {
            list.push({
                tweet,
                isNew: false,
            });
        }
        return list;
    };

    // handleSubmit も親で管理
    const handleSubmit = async (e) => {
        e.preventDefault();

        setIsLoading(true);
        try {
            await tweetClient.sendTweet(content);

            setContent("");
            setErrors({});
        } catch (error) {
            if (error.response?.status === 422) {
                setErrors(error.response.data.errors);
            }
        }
        setIsLoading(false);
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
