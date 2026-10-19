import { api } from "@/boot/axios"

export const getCustomers = (params = {}) => {
    return api.get('/costumers', { params }).then(({ data }) => data)
}

export const createCustomer = (params = {}) => {
    return api.post('/costumers', params).then(({ data }) => data)
}

export const updateCustomer = (id, params = {}) => {
    return api.put(`/costumers/${id}`, params).then(({ data }) => data)
}

export const deleteCustomer = (id) => {
    return api.delete(`/costumers/${id}`).then(({ data }) => data)
}