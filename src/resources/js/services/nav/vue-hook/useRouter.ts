import { ref, computed } from "vue";

/** Router用フック */
export function useRouter(components: any, init: string) {
    const current = ref(init);

    const isCurrent = (name: string) => {
        return current.value === name;
    };

    const setCurrent = (name: string) => {
        if (!(name in components)) throw Error(`not found route. name: ${name}`);
        current.value = name;
    };

    const currentComponent = computed(() => components[current.value]);

    return {
        isCurrent,
        setCurrent,
        currentComponent,
        currentName: () => {
            const val = current.value;

            return val;
        }
    };
}
