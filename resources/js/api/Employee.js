import Client from '../plugins/axios'
const resource = '/api';

export function getEmployee(data) {
    return Client({
        url: resource + '/employee',
        method: 'get',
        params: data
    })
}
export function createEmployee(data) {
    return Client({
        url: resource + '/employee',
        method: 'post',
        params: data
    })
}
export function updateEmployee(id, data) {
    return Client({
        url: resource + '/employee/' + id,
        method: 'put',
        params: data
    })
}
export function deleteEmployee(id) {
    return Client({
        url: resource + '/employee/' + id,
        method: 'delete',
    })
}