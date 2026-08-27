import http from "../services/http";

export const Http = {
    get: <Type = any>(url: string) => http.get<Type>(url).then(response => response.data),

    post: <Type = any>(url: string, data?: any) => http.post<Type>(url, data).then(response => response.data),

    put: <Type = any>(url: string, data?: any) => http.put<Type>(url, data).then(response => response.data),
    
    delete: <Type = any>(url: string) => http.delete<Type>(url).then(response => response.data),
};