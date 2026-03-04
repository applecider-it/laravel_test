import { ref } from "vue";

/** Router用フック */
export function useRouter(components: any, init: string) {
    const current = ref(init);

    const isCurrent = (name: string) => {
        return current.value === name;
    };

    const setCurrent = (name: string) => {
        current.value = name;
    };

    const currentComponent = () => components[current.value];

    return {
        isCurrent,
        setCurrent,
        currentComponent,
    };
}
