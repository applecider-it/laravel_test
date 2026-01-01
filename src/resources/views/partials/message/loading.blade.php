<div
  x-data="{ show: false }"
  x-init="setTimeout(() => show = true, 1000)"
  :class="show ? 'opacity-100' : ''"
  class="flex justify-center items-center h-52 text-gray-500 font-sans text-lg opacity-0 transition-opacity duration-500 ease-in"
>
    <div class="w-8 h-8 border-4 border-gray-300 border-t-gray-700 rounded-full animate-spin mr-2"></div>
    <div>読み込み中…</div>
</div>