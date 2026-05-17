document.querySelectorAll('[data-width]').forEach((bar) => {
    bar.style.width = `${Number(bar.dataset.width || 0)}%`;
});
