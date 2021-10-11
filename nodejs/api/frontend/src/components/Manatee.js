import React from 'react';
import { useParams } from 'react-router-dom';

export default function Manatee() {
    const { id } = useParams();
    if (!{ id }) {
        const { id } = 0;
    }

    return (
         <h2>Whale = { id }</h2>
    );
}