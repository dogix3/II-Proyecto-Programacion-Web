var Navbar = Reactstrap.Navbar;
var NavbarBrand = Reactstrap.NavbarBrand;
var NavbarToggler = Reactstrap.NavbarToggler;
var Collapse = Reactstrap.Collapse;
var Nav = Reactstrap.Nav;
var NavItem = Reactstrap.NavItem;
var NavLink = Reactstrap.NavLink;
var UncontrolledDropdown = Reactstrap.UncontrolledDropdown;
var DropdownToggle =  Reactstrap.DropdownToggle;
var DropdownMenu = Reactstrap.DropdownMenu;
var DropdownItem = Reactstrap.DropdownItem;
var Container = Reactstrap.Container;
var Row = Reactstrap.Row;
var Col = Reactstrap.Col;

class App extends React.Component {
    constructor(props) {
        super(props)
        this.state = { programas: [], programa: [], revisiones: [], revision: []  }
        this.handleReload = this.handleReload.bind(this);
        this.handleChangeData = this.handleChangeData.bind(this);
        this.handleChangePrograma = this.handleChangePrograma.bind(this);
        this.handleChangeRevision = this.handleChangeRevision.bind(this);
    }
    handleReload() {

         fetch('./server/index.php/programa')

           .then((response) => {

               return response.json()

           })

           .then((data) => {

               this.setState({ programas: data });

               this.forceUpdate();

           })



           fetch('./server/index.php/revision')

           .then((response) => {

               return response.json()

           })

           .then((data) => {

               this.setState({ revisiones: data });

               this.forceUpdate();

           })

       }
    componentWillMount() {
        this.handleReload();
    }
    handleChangeData() {
        this.handleReload();
    }
    handleChangePrograma(data) {
      this.setState({programa: data})
    }
    handleChangeRevision(data) {
      this.setState({revision: data})
    }
    render() {
        return (<div><Navbar color="light" light expand="md">
          <NavbarBrand href="/">Datos de Facturas</NavbarBrand>
          <NavbarToggler onClick={this.toggle} />
          <Collapse isOpen={this.state.isOpen} navbar>
            <Nav className="ml-auto" navbar>
              <NavItem>
                <NavLink href="http://programacion-con-reactjs.readthedocs.io">Tutorial</NavLink>
              </NavItem>
              <UncontrolledDropdown nav inNavbar>
                <DropdownToggle nav caret>
                  Options
                </DropdownToggle>
                <DropdownMenu right>
                  <DropdownItem>
                    Option 1
                  </DropdownItem>
                  <DropdownItem>
                    Option 2
                  </DropdownItem>
                  <DropdownItem divider />
                  <DropdownItem>
                    Reset
                  </DropdownItem>
                </DropdownMenu>
              </UncontrolledDropdown>
            </Nav>
          </Collapse>
        </Navbar><Container><Row>
        <Col xs="8"><ProgramasList programas={this.state.programas} 
                 handleChangePrograma={this.handleChangePrograma}/></Col>
        <Col xs="4"><ProgramasForm programa={this.state.programa}
                 handleChangeData={this.handleChangeData}/></Col>
        </Row>
        <Row>
        <Col xs="8"><RevisionesList revisiones={this.state.revisiones} 
                programa={this.state.programa}
                 handleChangeRevision={this.handleChangeRevision}/></Col>
        <Col xs="4"><RevisionesForm revision={this.state.revision}
                 handleChangeData={this.handleChangeData}/></Col>
        </Row></Container></div>)
    }
}
ReactDOM.render(<App/>, document.getElementById('root'));