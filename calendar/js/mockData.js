const ym0 = moment().format('YYYY-MM');
const ym1 = moment().subtract(1, 'month').format('YYYY-MM');
const ym2 = moment().add(1, 'month').format('YYYY-MM');
export const mockData = [

    {
        time: ym0 + '-13T08:00:00 Z',
        cls: 'bg-orange-alt',
        desc: 'Jack, Stephen',
        turn: 0
    },
    {
        time: ym0 + '1T08:00:00 Z',
        cls: 'bg-orange-alt',
        desc: 'Jack, Stephen',
        turn: 1
    },
    {
        time: ym0 + '-30T08:00:00 Z',
        cls: 'bg-orange-alt',
        desc: 'Adolfo, Sanchez',
        turn: 1
    },

    {
        time: ym0 + '-01T08:00:00 Z',
        cls: 'bg-orange-alt',
        desc: 'Adolfo, Sanchez',
        turn: 0
    },
    {
        time: ym0 + '-13T14:00:00 Z',
        cls: 'bg-green-alt',
        desc: 'Nathan, Luke',
        turn: 1
    },
    {
        time: ym0 + '-18T08:00:00 Z',
        cls: 'bg-red-alt',
        desc: 'Nathan, Stephen',
        turn: 0 
    },
    {
        time: ym0 + '-18T14:00:00 Z',
        cls: 'bg-cyan-alt',
        desc: 'Peter, Luke Skywalker',
        turn: 1
    },
    {
        time: ym0 + '-19T14:00:00 Z',
        cls: 'bg-sky-blue-alt',
        desc: 'Nathan, Luke',
        turn: 1
    },
    {
        time: ym0 + '-20T08:00:00 Z',
        cls: 'bg-orange-alt',
        desc: 'Peter Robert, Luke',
        turn: 0
    },
    {
        time: ym1 + '-05T14:00:00 Z',
        cls: 'bg-orange-alt',
        desc: 'Peter Andersen, Luke',
        turn: 1
    },
    {
        time: ym1 + '-06T14:00:00 Z',
        cls: 'bg-sky-blue-alt',
        desc: 'Peter Rodriguez, Lora',
        turn: 1
    },
    {
        time: ym1 + '-03T08:00:00 Z',
        cls: 'bg-orange-alt',
        desc: 'Sandy, Lora',
        turn: 0
    },
    {
        time: ym2 + '-05T08:00:00 Z',
        cls: 'bg-purple-alt',
        desc: 'Peter, Luke',
        turn: 0
    }
];