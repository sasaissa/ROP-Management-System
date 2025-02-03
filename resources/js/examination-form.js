document.addEventListener('DOMContentLoaded', function() {
    // Function to toggle retinal detachment section visibility
    function toggleRetinalDetachmentSection(eye) {
        const stage = document.getElementById(`${eye}_eye_stage`).value;
        const detachmentSection = document.getElementById(`${eye}_eye_detachment_section`);
        
        if (stage.startsWith('4') || stage.startsWith('5')) {
            detachmentSection.style.display = 'block';
        } else {
            detachmentSection.style.display = 'none';
        }
    }

    // Add event listeners for stage changes
    ['right', 'left'].forEach(eye => {
        const stageSelect = document.getElementById(`${eye}_eye_stage`);
        if (stageSelect) {
            stageSelect.addEventListener('change', () => toggleRetinalDetachmentSection(eye));
            // Initialize on page load
            toggleRetinalDetachmentSection(eye);
        }
    });

    // Handle clock hours selection
    function updateClockHours(eye) {
        const selectedHours = Array.from(document.querySelectorAll(`input[name="${eye}_eye_clock_hours[]"]:checked`))
            .map(cb => cb.value);
        document.getElementById(`${eye}_eye_clock_hours_input`).value = JSON.stringify(selectedHours);
    }

    ['right', 'left'].forEach(eye => {
        const clockHourCheckboxes = document.querySelectorAll(`input[name="${eye}_eye_clock_hours[]"]`);
        clockHourCheckboxes.forEach(cb => {
            cb.addEventListener('change', () => updateClockHours(eye));
        });
    });
});
