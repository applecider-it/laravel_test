/** ツイート */
type Tweet = {
    id: number | string;
    content: string;
    created_at: string;
    user: {
        name: string;
    };
};

/** ツイートコンテナー */
export type TweetContainer = {
    tweet: Tweet;
    isNew: boolean;
};

