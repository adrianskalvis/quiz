const addAnswerButton = document.getElementById('addAnswer');

if (addAnswerButton) {
    let answerCount = document.querySelectorAll('.answer-row').length;

    addAnswerButton.addEventListener('click', () => {
        const container = document.getElementById('answersContainer');
        const row = document.createElement('div');
        row.className = 'answer-row';
        row.innerHTML = `
        <input type="radio" name="correct_answer" class="answer-radio" value="${answerCount}">
        <input type="text" name="answers[]" class="form-input answer-input" placeholder="Answer option" required>
        <button type="button" class="btn-danger remove-answer answer-remove-btn">x</button>
    `;
        container.appendChild(row);
        answerCount++;
        updateValues();
    });

    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('remove-answer')) {
            if (document.querySelectorAll('.answer-row').length <= 2) return;
            event.target.closest('.answer-row').remove();
            updateValues();
        }
    });

    function updateValues() {
        document.querySelectorAll('.answer-row').forEach((row, index) => {
            row.querySelector('.answer-radio').value = index;
        });
    }
}
