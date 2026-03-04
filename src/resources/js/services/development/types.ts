import { type useRouter } from "@/services/nav/vue-hook/useRouter";

export type RouterPartsProps = {
    router: ReturnType<typeof useRouter>;
    setCurrent: (name: string) => void;
};
