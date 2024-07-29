<div class="dark:bg-gray-800 overflow-x-scroll shadow-sm sm:rounded-lg rounded-lg">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-none">
        <thead class="bg-gray-200">
            {{ $head }}
        </thead>
        <tbody class="bg-white dark:bg-gray-800 overflow-x-scroll">
            {{ $slot }}
        </tbody>
    </table>
</div>
