import { marked } from "marked";

const editor = document.getElementById("editor") as HTMLTextAreaElement;
const preview = document.getElementById("preview") as HTMLDivElement;

const makePreview = async(): Promise<void> => {
    const markdown: string = editor.value;
    preview.innerHTML = await marked.parse(markdown);
};

editor.addEventListener("input", () => {
    makePreview();
});

makePreview();