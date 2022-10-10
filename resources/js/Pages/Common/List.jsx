import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import List from '@/Shared/DisplayPageComponent/List/List';

export default function Show(props) {
    return (
        <MainLayout
            {...props}
        >
            <h1 className='attention'>Common List</h1>
            <List 
                {...props.list}
            ></List>
        </MainLayout>
    );
}