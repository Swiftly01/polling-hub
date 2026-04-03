
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Polling Unit Election Results - Nigeria 2011</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">
                        PU
                    </div>
                    <a href="/" class="text-xl font-bold text-gray-800">Polling Unit Results</a>
                </div>
                <div class="hidden md:flex space-x-6">
                    <a href="{{ route('polling-unit.lga-results') }}" class="text-gray-600 hover:text-blue-600 transition">
                        View Results
                    </a>
                    <a href="{{ route('polling-unit.create') }}" class="text-gray-600 hover:text-blue-600 transition">
                        Add Results
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 mt-12">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="font-bold text-white mb-2">About This System</h3>
                    <p class="text-sm">Polling Unit Election Results Management System - Nigeria 2011 Elections Data</p>
                </div>
                <div>
                    <h3 class="font-bold text-white mb-2">Features</h3>
                    <ul class="text-sm space-y-1">
                        <li>• View individual polling unit results</li>
                        <li>• View aggregated LGA results</li>
                        <li>• Store new polling unit results</li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-white mb-2">Technical Stack</h3>
                    <p class="text-sm">Built with Laravel, PHP 8.1+, and Tailwind CSS</p>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm">
                <p>&copy; 2026 Polling Unit Results System. User-friendly election data management.</p>
            </div>
        </div>
    </footer>
</body>
</html>
