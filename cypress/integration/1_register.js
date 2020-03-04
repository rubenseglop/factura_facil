context('Register and Edit Max Enterprises', () => {

    it('Visit Invoice', () => {
        cy.visit('http://localhost:8000/');
    });

    it('Register', () => {
        cy.visit('http://localhost:8000/register').click();
    });
    it('Fill Register', () => {
        cy.fixture('dataInvoice').then((fixedData) => {
            cy.get('#registration_form_email').type(fixedData.email)
            cy.get('#registration_form_name').type(fixedData.name)
            cy.get('#registration_form_plainPassword').type(fixedData.password)
            cy.get('#registration_form_agreeTerms').click();
            // REALIZAR REGISTRO
            cy.get('#register-submit-btn').click();
        })
    });

    var admin = "admin@admin.es";
    var pw = "administrador";
    var nEnterprises = 4;

    it('Login Admin, Check New User, Edit and Check', () => {
        cy.visit('http://localhost:8000/login');
        cy.get('#inputEmail').type(admin);
        cy.get('#inputPassword').type(pw);
        cy.get('#btnLogin').click();
        // Visitar vista admin
        cy.visit('http://localhost:8000/admin');
        // Listar Nuevo Usuario Creado
        cy.get('.title').contains('User').click();
        cy.fixture('dataInvoice').then((fixedData) => {
            cy.contains(fixedData.email);
        });
        // Edit number of enterprises
        cy.contains('invoiceUser').parents('tr').find('.action-edit').click({force:true});
        cy.get('#user_companyLimit').clear().type(nEnterprises);
        // Save
        cy.get('.action-save').click({ force:true });
        // Check number of enterprises
        cy.contains('invoiceUser').parents('tr').find('.integer').contains(nEnterprises);
    });

    it('LogOut Admin and Login New User', () => {
        /*cy.get('.user-name').click();
        cy.get('.user-action-logout').click({ force:true });*/
        cy.visit('http://localhost:8000/logout');
        // Login New User

        cy.visit('http://localhost:8000/login');
        cy.get('#inputEmail').type('prueba@cypress.io');
        cy.get('#inputPassword').type('prueba');
        cy.get('#btnLogin').click();

    });

});