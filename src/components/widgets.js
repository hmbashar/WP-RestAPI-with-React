import React, { useState, useEffect } from 'react';
import axios from 'axios';
import {
  LineChart,
  Line,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  Legend,
  ResponsiveContainer,
} from "recharts";


const Widgets = () => {
const [ApiData, setApiData] = useState();
const url = `${appLocalizer.apiURL}/cbwp/v2/settings`;

useEffect(() => {
    axios.get(url).then((res) => {
        setApiData(res.data);
        console.log(res.data);
    });
}, []);

const data = ApiData;
  return <div>
        <h2 style={{textAlign: 'center'}}>Chart Widgets</h2>
        <div style={{display: 'flex', justifyContent: 'space-between', alignItems: 'center', gap: '10px', padding: '10px', margin: '10px 0'}}>
            <h4>Select Time Range</h4>
            <select>
                <option value="7">Last 7 Days</option>
                <option value="15">Last 15 Days</option>
                <option value="30">Last 30 Days</option>
            </select>
        </div>
        <LineChart
          width={500}
          height={300}
          data={data}
          margin={{
            top: 5,
            right: 30,
            left: 20,
            bottom: 5,
          }}
        >
          <CartesianGrid strokeDasharray="3 3" />
          <XAxis dataKey="name" />
          <YAxis />
          <Tooltip />
          <Legend />
          <Line type="monotone" dataKey="pv" stroke="#8884d8" activeDot={{ r: 8 }} />
          <Line type="monotone" dataKey="uv" stroke="#82ca9d" />
        </LineChart>
      
  </div>;
};

export default Widgets;
