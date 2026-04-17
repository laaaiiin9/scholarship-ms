export function getErrorMessage(err) {
    if (typeof err === 'string' && err.trim()) {
        return err;
    }

    if (err?.errors) {
        const firstError = Object.values(err.errors).flat()[0];

        if (firstError) {
            return firstError;
        }
    }

    return 'Request failed.';
}