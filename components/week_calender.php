<div class="flex overflow-x-auto pb-4 mb-8 scrollbar-hide">
    <div id="weekButtons" class="flex space-x-2"></div>
</div>

<script>
    function getSelectedDateFromUrl() {
        const params = new URLSearchParams(window.location.search);
        const d = params.get('date');
        // expect YYYY-MM-DD
        if (d && /^\d{4}-\d{2}-\d{2}$/.test(d)) return d;
        return null;
    }

    function setDateInUrl(yyyyMmDd) {
        const params = new URLSearchParams(window.location.search);
        params.set('date', yyyyMmDd);
        window.location.search = params.toString();
    }

    function formatIsoDate(dateObj) {
        // local date -> yyyy-mm-dd (avoid timezone surprises)
        const y = dateObj.getFullYear();
        const m = String(dateObj.getMonth() + 1).padStart(2, '0');
        const d = String(dateObj.getDate()).padStart(2, '0');
        return `${y}-${m}-${d}`;
    }

    function generateWeekButtons() {
        const container = document.getElementById('weekButtons');
        if (!container) return;

        container.innerHTML = '';

        const selected = getSelectedDateFromUrl();
        const today = new Date();

        const options = {
            weekday: 'short',
            month: 'short',
            day: 'numeric'
        };

        for (let i = 0; i < 7; i++) {
            const date = new Date(today);
            date.setDate(today.getDate() + i);

            const formattedDate = formatIsoDate(date);
            const isActive = selected ? (formattedDate === selected) : (i === 0);

            const button = document.createElement('button');
            button.className = isActive ?
                'bg-amber-500 text-black px-4 py-2 rounded-md font-medium min-w-[100px]' :
                'bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-md min-w-[100px]';

            if (i === 0) button.textContent = 'Today';
            else if (i === 1) button.textContent = 'Tomorrow';
            else button.textContent = date.toLocaleDateString('en-US', options);

            button.addEventListener('click', () => setDateInUrl(formattedDate));
            container.appendChild(button);
        }

        // Hook up the date input (if present on the page)
        const dateInput = document.getElementById('dateInput');
        if (dateInput) {
            // Prefer native date input value (YYYY-MM-DD)
            if (dateInput.type !== 'date') dateInput.type = 'date';

            dateInput.value = selected ?? formatIsoDate(today);

            dateInput.addEventListener('change', () => {
                if (dateInput.value && /^\d{4}-\d{2}-\d{2}$/.test(dateInput.value)) {
                    setDateInUrl(dateInput.value);
                }
            });
        }
    }

    generateWeekButtons();
</script>