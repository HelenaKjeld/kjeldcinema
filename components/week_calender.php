<div class="flex overflow-x-auto pb-4 mb-8 scrollbar-hide">
     <div id="weekButtons" class="flex space-x-2"></div>
 </div>

 <script>
     function generateWeekButtons() {
         const container = document.getElementById('weekButtons');
         container.innerHTML = '';

         const today = new Date();
         const options = {
             weekday: 'short',
             month: 'short',
             day: 'numeric'
         };

         for (let i = 0; i < 7; i++) {
             const date = new Date(today);
             date.setDate(today.getDate() + i);

             const button = document.createElement('button');
             button.className =
                 i === 0 ?
                 'bg-amber-500 text-black px-4 py-2 rounded-md font-medium min-w-[100px]' :
                 'bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-md min-w-[100px]';

             if (i === 0) {
                 button.textContent = 'Today';
             } else if (i === 1) {
                 button.textContent = 'Tomorrow';
             } else {
                 button.textContent = date.toLocaleDateString('en-US', options);
             }

             // Redirect to page with ?date=YYYY-MM-DD
             button.addEventListener('click', () => {
                 const formattedDate = date.toISOString().slice(0, 10);
                 window.location.search = '?date=' + formattedDate;
             });

             container.appendChild(button);
         }

         // Set date picker placeholder to today's date
         document.getElementById('dateInput').placeholder = today.toLocaleDateString();
     }

     generateWeekButtons();
 </script>