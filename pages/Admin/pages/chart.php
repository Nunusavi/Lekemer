<link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
    rel="stylesheet" />
<link rel="stylesheet" href="./assets/css/tailwind.output.css" />
<script
    src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
    defer></script>
<script src="./assets/js/init-alpine.js"></script>
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"
    defer></script>
<script src="./assets/js/charts-lines.js" defer></script>
<script     defer>
    /**
     * For usage, visit Chart.js docs https://www.chartjs.org/docs/latest/
     */
    const pieConfig = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [33, 33, 33],
                /**
                 * These colors come from Tailwind CSS palette
                 * https://tailwindcss.com/docs/customizing-colors/#default-color-palette
                 */
                backgroundColor: ['#0694a2', '#1c64f2', '#7e3af2'],
                label: 'Dataset 1',
            }, ],
            labels: ['Shoes', 'Shirts', 'Bags'],
        },
        options: {
            responsive: true,
            cutoutPercentage: 80,
            /**
             * Default legends are ugly and impossible to style.
             * See examples in charts.html to add your own legends
             *  */
            legend: {
                display: false,
            },
        },
    }

    // change this to the id of your chart element in HMTL
    const pieCtx = document.getElementById('pie')
    window.myPie = new Chart(pieCtx, pieConfig)
</script>
<div class="grid gap-6 mb-5 md:grid-cols-2">
    <!-- Doughnut/Pie chart -->
    <div
        class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
            Doughnut/Pie
        </h4>
        <canvas id="pie"></canvas>
        <div
            class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
            <!-- Chart legend -->
            <div class="flex items-center">
                <span
                    class="inline-block w-3 h-3 mr-1 bg-blue-600 rounded-full"></span>
                <span>Shirts</span>
            </div>
            <div class="flex items-center">
                <span
                    class="inline-block w-3 h-3 mr-1 bg-teal-500 rounded-full"></span>
                <span>Shoes</span>
            </div>
            <div class="flex items-center">
                <span
                    class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"></span>
                <span>Bags</span>
            </div>
        </div>
    </div>
    <!-- Lines chart -->
    <div
        class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
            Lines
        </h4>
        <canvas id="line"></canvas>
        <div
            class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
            <!-- Chart legend -->
            <div class="flex items-center">
                <span
                    class="inline-block w-3 h-3 mr-1 bg-teal-500 rounded-full"></span>
                <span>Organic</span>
            </div>
            <div class="flex items-center">
                <span
                    class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"></span>
                <span>Paid</span>
            </div>
        </div>
    </div>
</div>