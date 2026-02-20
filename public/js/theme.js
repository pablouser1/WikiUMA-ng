/**
 * Handle theme switching.
 * Change theme and set cookie.
 */

const COOKIE_THEME_NAME = 'theme';
const THEME_SWITCHER_ID = 'theme-switcher';

const cookieExists = (name) => {
    const searchString = name + "=";

    return document.cookie.split(';').some(cookie => {
        const trimmedCookie = cookie.trim();
        return trimmedCookie.startsWith(searchString);
    });
}

const getCurrentTheme = () => {
    // Via dataset
    const themeDataset = document.documentElement.dataset.theme;
    if (themeDataset !== undefined) {
        return themeDataset;
    }

    // Via css / fallback
    return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
}

const saveTheme = (newTheme) => {
    document.cookie = `${COOKIE_THEME_NAME}=${newTheme}; path=/`;
}

const toggleTheme = () => {
    const theme = getCurrentTheme();
    const newTheme = theme === 'dark' ? 'light' : 'dark';
    if (!cookieExists(COOKIE_THEME_NAME) && newTheme === 'light') {
        new Audio('/audio/flashbang.opus').play();
    }
    document.documentElement.dataset.theme = newTheme;

    saveTheme(newTheme);
}

const setupListener = () => {
    const switcher = document.getElementById(THEME_SWITCHER_ID);

    switcher.addEventListener('click', toggleTheme);
}

setupListener();
