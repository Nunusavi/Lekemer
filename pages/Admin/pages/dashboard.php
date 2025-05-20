<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* Custom style */
        .header-right {
            width: calc(100% - 3.5rem);
        }

        /* .sidebar:hover {
        width: 16rem;
    } */

        @media only screen and (min-width: 768px) {
            .header-right {
                width: calc(100% - 16rem);
            }
        }
    </style>
</head>

<body>
    <script src="https://cdn.tailwindcss.com"></script>
    <div>
        <!-- Dashboard Background Pattern -->
        <div class="absolute top-0 z-[-2] min-h-full w-full bg-[#000000] bg-[radial-gradient(#ffffff33_1px,#00091d_1px)] bg-[size:20px_20px]">
            <div>
                <div class="flex flex-col flex-1 w-full">
                    <?php include __DIR__ . '/header.php'; ?>
                    <?php include __DIR__ . '/sidebar.php'; ?>
                    <div class="h-full ml-14 mt-14 mb-10 md:ml-64">
                        <?php include __DIR__ . '/statistics-cards.php'; ?>
                        <div class="p-4">
                            <!-- grid grid-cols-1 lg:grid-cols-2 p-4 gap-4 -->
                            <?php include __DIR__ . '/chart.php'; ?>
                        </div>
                        <div class="p-4">
                            <div class="mb-10"><?php include __DIR__ . '/recent-activities.php'; ?></div>
                            <?php include __DIR__ . '/client-table.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const setup = () => {
            const getTheme = () => {
                if (window.localStorage.getItem('dark')) {
                    return JSON.parse(window.localStorage.getItem('dark'))
                }
                return !!window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
            }

            const setTheme = (value) => {
                window.localStorage.setItem('dark', value)
            }

            return {
                loading: true,
                isDark: getTheme(),
                toggleTheme() {
                    this.isDark = !this.isDark
                    setTheme(this.isDark)
                },
            }
        }
        // Function to remove Grammarly-related attributes and elements
        (function removeGrammarlyArtifacts() {
            const body = document.querySelector('body');

            if (body) {
                body.removeAttribute('data-new-gr-c-s-check-loaded');
                body.removeAttribute('data-gr-ext-installed');
            }

            // Remove Grammarly editor overlays (if any exist)
            const grammarlyElements = document.querySelectorAll('[class*="gr_"], .grammarly-btn, .gr-scroller');

            grammarlyElements.forEach(el => el.remove());
        })();
    </script>
</body>

</html>