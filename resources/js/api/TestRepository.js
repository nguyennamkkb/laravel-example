import Client from '../plugins/axios'


export default function TestApi(query) {
    return Client({
        url: 'api/test',
        method: 'post',
        data: query
    })
}