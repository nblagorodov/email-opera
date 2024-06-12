import axios from "axios";

export const client = axios.create({
    timeout: 20000,
    headers: {
        'Content-Type': 'application/json;charset=UTF-8',
    }
})
