import React from 'react';
import { useParams } from 'react-router-dom';

export default function Formula() {
    const { id } = useParams();
    if (!{ id }) {
        const { id } = 0;
    }

    const [responseData, setResponseData] = React.useState('')
    const URI_API = 'http://localhost:8084/'

    React.useEffect(() => {
        async function fetchFormulas() {
            let data = JSON.stringify({"id": id});
            // console.log(':::: 1) ID ::::: ',data)
            // debugger
            const res = await fetch({
                    method: 'post',
                    url: URI_API+'get_all_formulas',
                    headers: {'Content-Type': 'application/json'},
                    data : data // body data type must match "Content-Type" header
                }
            );
            // console.log(':::: 2) ID ::::: ',id)
            let dataResult = await res.json(res);
            console.log('dataResult = ',dataResult)
            // let dataResult = await res.data;
            dataResult = JSON.stringify(dataResult);
            dataResult = JSON.parse(dataResult);
            let result = [];
            let jsonVal = '';
            for(var i in dataResult) {
                jsonVal = '';
                jsonVal = '{"group":"'+dataResult[i].group+'","version":"'+dataResult[i].version+'","formula":"'+dataResult[i]._id+'"}';
                jsonVal = JSON.parse(jsonVal);
                result.push(jsonVal);
            }
            setResponseData(result)
            // console.log(" ::: result ::: " , result)
        }
        fetchFormulas();
    }, []);

    return (
        <h2>Formula id = { id }</h2>
    );
}
