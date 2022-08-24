import Client from '../plugins/axios'
const resource = '/api';

export function getWarehouse(data) {
    return Client({
        url: resource + '/warehouse',
        method: 'get',
        params: data
    })
}