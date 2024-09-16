

<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-3 py-2 bg-blue-800 rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
