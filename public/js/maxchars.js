const updateCounter = (maxLength, inputElement, counterElement) => {
    const currentLength = inputElement.value.length;
    const remaining = maxLength - currentLength;

    counterElement.textContent = `${currentLength}/${maxLength}`;

    // Apply Bulma's 'is-danger' style if the length exceeds the max
    if (remaining <= 0) {
        counterElement.classList.add('is-danger');
    } else {
        counterElement.classList.remove('is-danger');
    }
};


const initMaxChars = () => {
    const inputs = document.querySelectorAll('input[maxlength], textarea[maxlength]');

    inputs.forEach(inputElement => {
        const maxLength = parseInt(inputElement.getAttribute('maxlength'), 10);

        // Find field
        const fieldContainer = inputElement.closest('.field');
        if (!fieldContainer) return;

        // Create element
        const counterElement = document.createElement('p');
        counterElement.classList.add('help');

        // Insert element, if another help already exists then place on top of it.
        const firstExistingHelp = fieldContainer.querySelector('p.help');
        if (firstExistingHelp) {
            fieldContainer.insertBefore(counterElement, firstExistingHelp);
        } else {
            fieldContainer.appendChild(counterElement);
        }

        // Handle input event
        inputElement.addEventListener('input', () => updateCounter(maxLength, inputElement, counterElement));
        updateCounter(maxLength, inputElement, counterElement);
    });
}

initMaxChars();
