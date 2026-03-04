/** ルーターテストのパーツのProps */
export type RouterPartsProps = {
    setCurrent: (name: string) => void;
};

type RouterComponentInfo = {
    sort: number;
};

/** ルーターの詳細情報 */
export type RouterComponentInfos = {
    [key: string]: RouterComponentInfo;
};
