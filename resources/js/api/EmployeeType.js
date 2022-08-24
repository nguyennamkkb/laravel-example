import Client from '../plugins/axios'
const resource = '/api';

export function getEmployeeType(data) {
    return Client({
        url: resource + '/employeeType',
        method: 'get',
        params: data
    })
}
export function createEmployeeType(data) {
    return Client({
        url: resource + '/employeeType',
        method: 'post',
        params: data
    })
}
export function updateEmployeeType(id, data) {
    return Client({
        url: resource + '/employeeType/' + id,
        method: 'put',
        params: data
    })
}
export function deleteEmployeeType(id) {
    return Client({
        url: resource + '/employeeType/' + id,
        method: 'delete',
    })
}