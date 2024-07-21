@props(['heading'])

<section class="px-6 py-8">
    <main class="max-w-4px mx-auto mt-10">

        <h1 class="text-lg font-bold mb-8 pb-2 border-b"> {{ $heading }} </h1>

        <div class="flex">
            <aside class="w-48 flex-shrink-0">
                <h4 class="font-semibold mb-4"> Menú </h4>
                <ul>
                    <li>
                        <a href="#" class="{{ request()->is('/') ? 'text-blue-500' : '' }}"> amodificar </a>
                    </li>
                    <li>
                        <a href="#" class="{{ request()->is('/') ? 'text-blue-500' : '' }}"> A modificar </a>
                    </li>
                </ul>
            </aside>

            <section class="flex-1">
                {{ $slot }}
            </section>
        </div>
    </main>
</section>
