

class Calendar {
    constructor(elementId, options = {}) {
        this.container = document.getElementById(elementId);
        if (!this.container) {
            console.error(`Calendar container #${elementId} not found`);
            return;
        }

        this.options = Object.assign({
            onDateSelect: null,
            events: [], // Array of { date: 'YYYY-MM-DD', status: 'full'|'partial'|'maintenance' }
            locale: 'fr-FR',
            allowPastDates: false
        }, options);

        this.currentDate = new Date();
        this.selectedDate = null;

        this.monthNames = [
            "Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
            "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"
        ];

        this.init();
    }

    init() {
        this.render();
        this.attachStyles();
    }

    attachStyles() {
        // Inject dynamic styles if not already present
        if (!document.getElementById('calendar-styles')) {
            const style = document.createElement('style');
            style.id = 'calendar-styles';
            style.textContent = `
                .calendar-wrapper {
                    background: var(--surface-card, #ffffff);
                    border-radius: 1rem;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                    padding: 1.5rem;
                    font-family: inherit;
                }
                .calendar-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 1.5rem;
                }
                .calendar-title {
                    font-size: 1.25rem;
                    font-weight: 700;
                    color: var(--text-primary, #1f2937);
                    text-transform: capitalize;
                }
                .calendar-nav-btn {
                    background: transparent;
                    border: 1px solid var(--border-color, #e5e7eb);
                    border-radius: 0.5rem;
                    padding: 0.5rem;
                    cursor: pointer;
                    transition: all 0.2s;
                    color: var(--text-secondary, #6b7280);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                .calendar-nav-btn:hover {
                    background: var(--bg-hover, #f3f4f6);
                    color: var(--primary-color, #4f46e5);
                }
                .calendar-grid {
                    display: grid;
                    grid-template-columns: repeat(7, 1fr);
                    gap: 0.5rem;
                    text-align: center;
                }
                .calendar-weekday {
                    font-size: 0.875rem;
                    font-weight: 600;
                    color: var(--text-secondary, #9ca3af);
                    padding-bottom: 0.75rem;
                }
                .calendar-day {
                    aspect-ratio: 1;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 0.95rem;
                    border-radius: 0.5rem;
                    cursor: pointer;
                    transition: all 0.2s;
                    position: relative;
                    border: 2px solid transparent;
                }
                .calendar-day:not(.empty):hover {
                    background-color: var(--bg-hover, #f3f4f6);
                }
                .calendar-day.today {
                    color: var(--primary-color, #4f46e5);
                    font-weight: 700;
                    background-color: var(--primary-light, #eef2ff);
                }
                .calendar-day.selected {
                    background-color: var(--primary-color, #4f46e5) !important;
                    color: white !important;
                    transform: scale(1.05);
                    box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3);
                }
                .calendar-day.disabled {
                    opacity: 0.3;
                    cursor: not-allowed;
                    background: none !important;
                }
                /* Status Indicators */
                .day-status {
                    position: absolute;
                    bottom: 4px;
                    width: 6px;
                    height: 6px;
                    border-radius: 50%;
                }
                .status-full { background-color: #ef4444; }
                .status-partial { background-color: #f59e0b; }
                .status-maintenance { background-color: #6b7280; }
                
                /* Animations */
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(5px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                .calendar-grid {
                    animation: fadeIn 0.3s ease-out;
                }
            `;
            document.head.appendChild(style);
        }
    }

    render() {
        // Clear container
        this.container.innerHTML = '';

        const wrapper = document.createElement('div');
        wrapper.className = 'calendar-wrapper';

        // Header
        const header = document.createElement('div');
        header.className = 'calendar-header';

        const prevBtn = document.createElement('button');
        prevBtn.className = 'calendar-nav-btn';
        prevBtn.innerHTML = `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>`;
        prevBtn.onclick = () => this.changeMonth(-1);

        const title = document.createElement('div');
        title.className = 'calendar-title';
        title.textContent = `${this.monthNames[this.currentDate.getMonth()]} ${this.currentDate.getFullYear()}`;

        const nextBtn = document.createElement('button');
        nextBtn.className = 'calendar-nav-btn';
        nextBtn.innerHTML = `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>`;
        nextBtn.onclick = () => this.changeMonth(1);

        header.append(prevBtn, title, nextBtn);
        wrapper.append(header);

        // Grid
        const grid = document.createElement('div');
        grid.className = 'calendar-grid';

        // Weekdays
        const weekdays = ['Lun', ' Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
        weekdays.forEach(day => {
            const el = document.createElement('div');
            el.className = 'calendar-weekday';
            el.textContent = day;
            grid.appendChild(el);
        });

        // Days
        const firstDay = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth(), 1);
        const lastDay = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 0);

        // Adjust for Monday start (0=Sun, 1=Mon)
        let firstDayIndex = firstDay.getDay() - 1;
        if (firstDayIndex === -1) firstDayIndex = 6;

        // Empty cells before first day
        for (let i = 0; i < firstDayIndex; i++) {
            const el = document.createElement('div');
            el.className = 'calendar-day empty';
            grid.appendChild(el);
        }

        // Actual days
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        for (let i = 1; i <= lastDay.getDate(); i++) {
            const el = document.createElement('div');
            el.className = 'calendar-day';
            el.textContent = i;

            const currentDayDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth(), i);
            const dateString = currentDayDate.toISOString().split('T')[0];

            // Check if today
            if (currentDayDate.getTime() === today.getTime()) {
                el.classList.add('today');
            }

            // Check if selected
            if (this.selectedDate && currentDayDate.getTime() === this.selectedDate.getTime()) {
                el.classList.add('selected');
            }

            // Check past dats
            if (!this.options.allowPastDates && currentDayDate < today) {
                el.classList.add('disabled');
            } else {
                el.onclick = () => this.selectDate(currentDayDate);
            }

            // Add status/events
            const event = this.options.events.find(e => e.date === dateString);
            if (event) {
                const dot = document.createElement('div');
                dot.className = `day-status status-${event.status}`;
                dot.title = event.title || '';
                el.appendChild(dot);
            }

            grid.appendChild(el);
        }

        wrapper.appendChild(grid);
        this.container.appendChild(wrapper);
    }

    changeMonth(delta) {
        this.currentDate.setMonth(this.currentDate.getMonth() + delta);
        this.render();
    }

    selectDate(date) {
        this.selectedDate = date;
        this.render();
        if (this.options.onDateSelect) {
            this.options.onDateSelect(date.toISOString().split('T')[0]);
        }
    }
}

// Make available globally
window.Calendar = Calendar;
