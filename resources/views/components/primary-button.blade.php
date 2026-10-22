<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#174f46] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#103e37] focus:bg-[#103e37] active:bg-[#0d352f] focus:outline-none focus:ring-2 focus:ring-[#4e8273] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
