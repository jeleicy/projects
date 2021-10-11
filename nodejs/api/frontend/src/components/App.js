import React from 'react'
import Table, { AvatarCell, SelectColumnFilter, StatusPill } from './Table'  // new
import Test from './Test'  // new
const axios = require('axios')
require('dotenv').config()

const getData =  () => {
    const data = []
    return [...data]
}

function App() {
    const [responseData, setResponseData] = React.useState(getData())
    const columns = React.useMemo(() => [
        {
          Header: "Group",
          accessor: 'group',
        },
        {
          Header: "Version",
          accessor: 'version',
        },
        {
          Header: "Formula",
          accessor: 'formula',
          // Cell: StatusPill,
        },
    ], [])

    const URI_API = 'http://localhost:8084/'
    const userObject = {}
    var dataAxios = getData();

    React.useEffect(() => {
        async function fetchFormulas() {
            const res = await fetch(
                URI_API+'get_all_formulas'
            );
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
            console.log(" ::: result ::: " , result)
        }
        fetchFormulas();
    }, []);

    // const data = React.useMemo(() => getData(), [])
    return (
        <div className="min-h-screen bg-gray-100 text-gray-900">
            <main className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                <div className="mt-6">
                    <Table columns={columns} data={responseData}/>
                </div>
            </main>
        </div>
    );
}

export default App;
