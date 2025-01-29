export async function countLend() {
    try {
        const response = await fetch('getCounts.php');
        const data = await response.json();
        return data.realLend;
    } catch (error) {
        console.error('Error fetching lend count:', error);
        return 0; // Return 0 or handle the error as needed
    }
}

export async function countBook() {
    try {
        const response = await fetch('getCounts.php');
        const data = await response.json();
        return data.realBook;
    } catch (error) {
        console.error('Error fetching book count:', error);
        return 0; // Return 0 or handle the error as needed
    }
}

export async function sumCount() {
    const realLend = await countLend();
    const realBook = await countBook();
    return realLend + realBook;
}
