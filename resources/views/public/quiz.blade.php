<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect" />
	<link as="style" href="https://fonts.googleapis.com/css2?display=swap&amp;family=Lexend%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900" onload="this.rel='stylesheet'" rel="stylesheet" />
	<title>EduQuiz - Kuis Bahasa Inggris</title>
	<link href="data:image/x-icon;base64," rel="icon" type="image/x-icon" />
	<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
	<style type="text/tailwindcss">
		:root {
      --primary-color: #3d98f4;
      --radio-svg: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='%233d98f4' xmlns='http://www.w3.org/2000/svg'%3e%3ccircle cx='8' cy='8' r='3'/%3e%3c/svg%3e");
    }
    .material-icons {
      font-family: 'Material Icons';
      font-weight: normal;
      font-style: normal;
      font-size: 24px;
      display: inline-block;
      line-height: 1;
      text-transform: none;
      letter-spacing: normal;
      word-wrap: normal;
      white-space: nowrap;
      direction: ltr;
      -webkit-font-smoothing: antialiased;
      text-rendering: optimizeLegibility;
      -moz-osx-font-smoothing: grayscale;
      font-feature-settings: 'liga';
    }
</style>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
</head>

<body class="bg-slate-50" style='font-family: Lexend, "Noto Sans", sans-serif;'>
	<div class="relative flex size-full min-h-screen flex-col group/design-root overflow-x-hidden">
		<div class="layout-container flex h-full grow flex-col">
			<header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-slate-200 bg-white px-6 sm:px-10 py-4 shadow-sm">
				<div class="flex items-center gap-3">
					<div class="text-[var(--primary-color)]">
						<svg class="lucide lucide-graduation-cap" fill="none" height="32" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="32" xmlns="http://www.w3.org/2000/svg">
							<path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.084a1 1 0 0 0 0 1.838l8.57 3.908a2 2 0 0 0 1.66 0l8.59-3.908Z"></path>
							<path d="M6 12v4c0 4.556 3.076 8 7 8s7-3.444 7-8v-4"></path>
						</svg>
					</div>
					<h1 class="text-slate-900 text-xl font-bold tracking-tight">EduQuiz</h1>
				</div>
				<nav class="hidden md:flex items-center gap-8">
					<a class="text-[var(--text-primary)] hover:text-[var(--primary-color)] text-sm font-medium leading-normal py-2 transition-colors" href="landing-page.html">Home</a>
					<a class="nav-link-active text-sm font-medium leading-normal py-2 transition-colors" href="chapter.html">Chapter</a>
					<a class="text-[var(--text-primary)] hover:text-[var(--primary-color)] text-sm font-medium leading-normal py-2 transition-colors" href="quiz.html">Quiz</a>
					<a class="text-[var(--text-primary)] hover:text-[var(--primary-color)] text-sm font-medium leading-normal py-2 transition-colors" href="score.html">Score</a>
				</nav>
				<div class="flex items-center gap-3 sm:gap-4">
					<button aria-label="Notifikasi" class="flex items-center justify-center rounded-full h-10 w-10 hover:bg-slate-100 text-slate-600 transition-colors">
						<i class="material-icons text-2xl">notifications_none</i>
					</button>
					<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 border-2 border-slate-200" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAPK-bOkEWfDN6S9GNB1FEBJcmjCk6RvaRCKIMZJPhumUSCD-GGos0POFvDGVnXpG5Mj1EdAXI8kPTCJBB5KdCTLrYGlkSbxACNtJqElryDZgWq97Ru6TPL7jLfomigWhvrKS4PCdExYnTuxWA4SKIDxxxMPgI-Dm2tj9BoPrGUZK6P_5N8E4JbxLZIbaIZkFOw70qvZ2F-oVYx6kaPd24q7f4GTpBSfZ2pQTYQDhyw7gJQViBABHc62_8KwdGAyuCt8i7kerD7jCZh");'>
					</div>
					<button aria-label="Menu" class="sm:hidden flex items-center justify-center rounded-md h-10 w-10 hover:bg-slate-100 text-slate-600 transition-colors">
						<i class="material-icons text-2xl">menu</i>
					</button>
				</div>
			</header>
			<main class="flex flex-1 justify-center py-8 sm:py-12 px-4">
				<div class="bg-white shadow-xl rounded-lg w-full max-w-2xl p-6 sm:p-8">
					<div class="mb-6 sm:mb-8">
						<div class="flex items-center justify-between mb-2">
							<h2 class="text-slate-900 text-xl sm:text-2xl font-bold tracking-tight">Kuis Bahasa Inggris</h2>
							<div class="text-sm text-slate-600 font-medium">
								Soal <span class="font-bold text-slate-800">{{ $currentIndex }}</span> dari <span class="font-bold text-slate-800">{{ $total }}</span>
							</div>
						</div>
						<div class="w-full bg-slate-200 rounded-full h-2.5">
							<div class="bg-[var(--primary-color)] h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
						</div>
					</div>

					<div class="mb-6">
						<p class="text-slate-800 text-base sm:text-lg font-medium leading-relaxed">
							{!! $question->question_text !!}
						</p>
					</div>

					<div class="space-y-4">
						@foreach ($question->options as $key => $value)
						<label class="flex items-center gap-x-3 p-4 rounded-lg border border-slate-200 hover:border-[var(--primary-color)] transition-all cursor-pointer">
							<input type="radio" name="option" value="{{ $key }}" class="h-5 w-5 text-[var(--primary-color)]">
							<span class="text-slate-700 text-base">{{ $value }}</span>
						</label>
						@endforeach
					</div>

					<div class="mt-8 flex justify-between items-center">
						<button wire:click="previousQuestion" class="flex items-center justify-center gap-2 rounded-lg h-11 px-6 bg-slate-200 text-slate-700 text-sm font-bold hover:bg-slate-300">
							<i class="material-icons text-lg">arrow_back</i>
							<span>Sebelumnya</span>
						</button>

						<button wire:click="nextQuestion" class="flex items-center justify-center gap-2 rounded-lg h-11 px-6 bg-[var(--primary-color)] text-white text-sm font-bold hover:bg-blue-600">
							<span>Berikutnya</span>
							<i class="material-icons text-lg">arrow_forward</i>
						</button>
					</div>
				</div>

			</main>
			<footer class="py-8 text-center border-t border-solid border-t-[var(--border-color)] bg-slate-50">
				<p class="text-sm text-[var(--text-secondary)]">© 2025 EduQuest.</p>
			</footer>
		</div>
	</div>
	<script>
		// Simple script to enable/disable button based on radio selection
		const radioButtons = document.querySelectorAll('input[name="quiz_option"]');
		const nextButton = document.querySelector('button.bg-\\[var\\(--primary-color\\)\\]');
		const prevButton = document.querySelectorAll('button')[3]; // Assuming 'Sebelumnya' is the 4th button
		function updateButtonState() {
			const anyChecked = Array.from(radioButtons).some(rb => rb.checked);
			if (nextButton) {
				nextButton.disabled = !anyChecked;
			}
		}
		radioButtons.forEach(rb => rb.addEventListener('change', updateButtonState));
		if (prevButton) {
			prevButton.disabled = true; // Disable previous button on the first question by default
		}
		updateButtonState(); // Initial check
	</script>
</body>

</html>