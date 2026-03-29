import { csrfToken } from '../utils/csrf';

export async function post(url, data) {

    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: data
    });

    const result = await response.json().catch(() => ({
        ok: false,
        msg: 'Unexpected server response.',
    }));

    if (!response.ok || result.ok === false) {
        throw result;
    }

    return result;
}
