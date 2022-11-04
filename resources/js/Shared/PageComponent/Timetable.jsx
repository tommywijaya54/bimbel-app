export default ({schedules}) => {
    const Today = dn.getToday();
    const isToday = (date) => {
        if(dn.date(Today) == dn.date(dn.justDate(date))){
            return 'today highlight';
        }

        if(Today > dn.justDate(date)){
            return 'past opacity-60';
        }
        
        return 'future';
    }

    return <>
        <div className="schedules grid grid-cols-1 gap-4 md:grid-cols-3">
            {schedules.map((schedule) => {
                return (
                    <div className='schedule br-1' key={schedule.id}>
                        <div className=' bg-orange-100 px-6 py-4'>
                            <h2 className='font-semibold text-lg mb-2'>{schedule.class_subject}</h2>
                            <span>{schedule.class_room}</span>
                            <span className="float-right">{schedule.teacher.name}</span>
                        </div>
                        
                        <table className="w-full table-padding-row">
                            <tbody>
                            {schedule.items.map(item => {
                                return <tr key={item.id} className={isToday(item.session_date)}>
                                    <td>{dn.date(item.session_date)}</td>
                                    <td className="text-right">{dn.time(item.session_start_time)}</td>
                                    <td className="text-right">{dn.time(item.session_end_time)}</td>
                                </tr>
                            })}
                            </tbody>
                        </table>
                    </div>
                )
            })}
        </div>
    </>
}