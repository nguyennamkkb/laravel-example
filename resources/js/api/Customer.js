import Client from '../plugins/axios'
const resource = '/api';

export function getCustomer(data) {
    return Client({
        url: resource + '/customer',
        method: 'get',
        params: data
    })
}
export function createCustomer(data) {
    return Client({
        url: resource + '/customer',
        method: 'post',
        params: data
    })
}
export function updateCustomer(id, data) {
    return Client({
        url: resource + '/customer/' + id,
        method: 'put',
        params: data
    })
}
export function deleteCustomer(id) {
    return Client({
        url: resource + '/customer/' + id,
        method: 'delete',
    })
}