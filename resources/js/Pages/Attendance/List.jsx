import MainLayout from "@/Layouts/MainLayout"
import Component from "@/Shared/PageComponent/Form/Component"

const SessionCard = ({session}) => {
    let {item, schedule} = session;    
    return (
        <a href={route('attendance',item.id)} className='link-outline'>
            <div className='schedule br-1' key={schedule.id}>
                <div className={(item.today ?'bg-orange-100':'') +' px-6 py-4'}>
                    <h2 className='font-semibold text-lg mb-2'>{schedule.class_subject}</h2>
                    <span>{schedule.class_room}</span>
                    <span className="float-right">{schedule.teacher.name}</span>
                </div>
                <table className="w-full table-padding-row">
                    <tbody>
                        <tr key={item.id} className={item.today ? 'highlight' : ''}>
                            <td>{dn.date(item.session_date)}</td>
                            <td className="text-right">{dn.time(item.session_start_time)}</td>
                            <td className="text-right">{dn.time(item.session_end_time)}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </a>
    )
}

const AttendanceList = ({schedules}) => {
    let todaySchedule = [];
    let nextSchedule = [];
    
    const TodayDate = dn.date(new Date());
    const Today = dn.getToday();
    const isToday = (date) => {
        return TodayDate == date
    }
    let next = false;

    schedules.forEach(schedule => {
        next = false;
        schedule.items.forEach(item => {
            item.session_date = dn.justDate(item.session_date);

            if(item.session_date > Today && !next){
                item.next_schedule = true;
                nextSchedule.push({item,schedule});
                next = true;
            }

            if(isToday(dn.date(item.session_date))){
                item.today = true;
                todaySchedule.push({item,schedule});
            }
        })
    });

    return <>
        <div className="mb-6">
            <h2 className="text-lg font-semibold mb-2">Today Schedule</h2>
            <div className="schedules grid grid-cols-1 gap-4 md:grid-cols-3">
                {todaySchedule.map((session) => {
                    return <SessionCard session={session} key={session.item.id}/>
                })}
            </div>
        </div>
        <div className="opacity-80">
            <h2 className="text-lg font-semibold mb-2">Next Schedule</h2>
            <div className="schedules grid grid-cols-1 gap-4 md:grid-cols-3">
                {nextSchedule.map((session) => {
                    return <SessionCard session={session} key={session.item.id}/>
                })}
            </div>
        </div>
        
    </>
}
export default (props) => {
    return <>
        <MainLayout {...props}>
            <div className="w-full">
                <Component
                    header={
                        <h2 className="font-semibold text-xl text-gray-800 leading-tight">Attendance List</h2>
                    }
                    className={'create-form no-padding'}
                >
                    <div className='grow p-6'>
                        <AttendanceList schedules={props.schedules} />
                    </div>
                </Component>
            </div>
        </MainLayout>
    </>
}