export default class TaskList {
    constructor(elementTree) {
        this.elementTree = elementTree
        this.steps = []
    }

    parse() {
        this.toNext(this.getStartElement())
    }

    toNext(element) {
        let id = null
        switch (this.getType(element)) {
            case 'flow':
                id = element.targetRef
                break
            case 'step':
                this.steps.push(element)
                id = element.outgoingFlows.length > 0 ? element.outgoingFlows[0].id : null
                break
            case 'start':
                id = element.outgoingFlows.length > 0 ? element.outgoingFlows[0].id : null
                break
            default:
                break
        }

        if (id != null) {
            this.toNext(this.getElementByID(id))
        }
    }

    getStartElement() {
        return _.find(this.elementTree.flowElements, (element) => {
            if (element.incomingFlows && element.incomingFlows.length === 0) {
                return element
            }
        })
    }

    getEndElement() {
        return _.find(this.elementTree.flowElements, (element) => {
            if (element.outgoingFlows && element.outgoingFlows.length === 0) {
                return element
            }
        })
    }

    getElementByID(id) {
        return _.find(this.elementTree.flowElements, (element) => {
            if (element.id === id) {
                return element
            }
        })
    }

    getNextElementByID(id) {
        let element = this.getElementByID(id)
        if(element.outgoingFlows.length == 1) {
            return this.getElementByID(element.outgoingFlows[0].targetRef)
        } else {
            return null
        }
    }

    getType(element) {
        if (element.hasOwnProperty('sourceRef') && element.hasOwnProperty('targetRef')) {
            return 'flow'
        } else if (element.hasOwnProperty('incomingFlows') &&
            element.incomingFlows.length > 0 &&
            element.hasOwnProperty('outgoingFlows') &&
            element.outgoingFlows.length > 0) {
            return 'step'
        } else if (element.incomingFlows && element.incomingFlows.length === 0) {
            return 'start'
        }
    }

    getSteps() {
        return this.steps
    }
}
