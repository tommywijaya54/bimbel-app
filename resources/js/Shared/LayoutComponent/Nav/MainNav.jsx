import React from 'react';
import Nav from './Nav';
export default () => {
    return <>
        <Nav route_name='dashboard'>Dashboard</Nav>
        <Nav route_name='chat'>Chat</Nav>
        <Nav route_name='timetable'>My Timetable</Nav>

        <Nav route_name='schedule'>Schedule</Nav>
        <Nav route_name='attendance'>Attendance</Nav>
    </>;
}
